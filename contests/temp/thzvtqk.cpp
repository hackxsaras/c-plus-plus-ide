#include <bits/stdc++.h>
using namespace std;
vector<pair<long long,long long>> cords;
vector<int> sinked;
int sinks=0;
long long pow2(long long n){
   return n*n;
}
void sinknear(int k){
   int si=-1,sd=LONG_MAX;
   for(int i=0;i<cords.size();i++){
      if(i==k || sinked[i])continue;
      long long d = pow2(cords[k].first - cords[i].first) + pow2(cords[k].second - cords[i].second);
      if(d<sd){
         sd=d;
         si=i;
      } 
   }
   //cout<<"SINKING "<<si+1<<"\n";
   sinked[si]=1;
   sinks++;
}
int main(){
   int n;
   cin>>n;
   sinked.resize(n);
   cords.resize(n);
   long long x,y;
   for(int i=0;i<n;i++){
      cin>>x>>y;
      cords[i] = make_pair(x,y);
   }
   for(int i=0;i<n && sinks!=n-1 ; i++){
      if(!sinked[i])sinknear(i);
      if(i==n-1&&sinks!=n-1)i=0;
   }
   for(int i=0;i<n;i++){
      if(!sinked[i]){
         cout<<i+1;//kamin
         break;
      }
   }
   return 0;
}