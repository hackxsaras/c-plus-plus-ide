#include <bits/stdc++.h>
using namespace std;
int main(){
   int w,h,x,y;
   cin>>w>>h;
   cin>>x>>y;
   int tx,ty;
   int m=0,n;
   cin>>n;
   for(int i=0;i<n;i++){
      cin>>tx>>ty;
      if(abs(tx-ty)==abs(x-y)){
         m+=1;
      } else if(tx==x){
         m+=1;
      } else if(ty==y){
         m+=1;
      } else {
         m+=2;
      }
      x=tx;
      y=ty;
   }
   cout<<m<<"\n";
   return 0;
}