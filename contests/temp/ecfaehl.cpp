#include <bits/stdc++.h>
using namespace std;
int main(){
   int n;
   cin>>n;
   vector<int> l;
   vector<int> r;
   vector<pair<int,int>> rh(n);
   for(int i=0;i<n;i++){
      cin>>rh[i].first >> rh[i].second;
   }
   for(int i=0;i<n;i++){
      if(rh[i].second=='l'){
         rh.top();
      }
   }
   return 0;
}